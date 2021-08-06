<?php

namespace EricMurano\DataRetrievers;

use EricMurano\Core\Database\DatabaseFactory;

class ExtraQueryTransactionReportRetriever implements TransactionReportRetriever
{
    private DatabaseFactory $databaseFactory;

    /**
     * @param DatabaseFactory $databaseFactory
     */
    public function __construct(DatabaseFactory $databaseFactory)
    {
        $this->databaseFactory = $databaseFactory;
    }

    public function recordCount(string $searchTerm): int
    {
        $dbConn = $this->databaseFactory->connect();
        $query = "SELECT COUNT(*) as totalRecords\n";
        $query .= $this->commonQuery($searchTerm);
        $statement = $dbConn->query($query);
        return $statement->fetchColumn();
    }

    public function findPage(string $searchTerm, PagingConfiguration $pagingConfiguration): array
    {
        $dbConn = $this->databaseFactory->connect();

        $query = "
            SELECT t.id,
                   t.starttime as startTime,
                   t.finishtime as finishTime,
                   t.notes,
                   c.firstname as firstName,
                   c.lastname as lastName,
                   c.role
            ";
        $query .= $this->commonQuery($searchTerm);
        $query .= "
            ORDER BY t.starttime desc, t.id desc
            LIMIT ".$pagingConfiguration->getPage() . "," . $pagingConfiguration->getPageSize();

        $statement = $dbConn->query($query);
        $rowData = [];
        while(($row = $statement->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $row['items'] = $this->findItems($dbConn, $row['id']);
            $rowData[] = $row;
        }

        return $rowData;
    }

    private function commonQuery(string $searchTerm): string
    {
        $query = "
            FROM shoptransaction t
            JOIN cashier c ON c.id = t.cashierid
        ";

        if (strlen($searchTerm) > 0) {
            $query .=  "
                WHERE t.notes like '%" . str_replace('"', '""', $searchTerm) . "%'
                OR c.firstname like '%" . str_replace('"', '""', $searchTerm) . "%'
                OR c.lastname like '%" . str_replace('"', '""', $searchTerm) . "%'
                OR c.role like '%" . str_replace('"', '""', $searchTerm) . "%'
                OR t.id in (
                    select b.transactionid
                    from itemtransactionbridge b
                    join item i ON i.id = b.itemid
                    where i.itemname like '%" . str_replace('"', '""', $searchTerm) . "%'
                )
            ";
        }

        return $query;
    }

    private function findItems(\PDO $dbConn, int $transactionId) : string
    {
        $query = "
            SELECT i.itemname
            FROM itemtransactionbridge b
            JOIN item i ON i.id = b.itemid
            WHERE b.transactionid = :transactionId
        ";

        $statement = $dbConn->prepare($query);
        $statement->bindValue('transactionId', $transactionId);
        $statement->execute();
        $items = [];
        while (($row = $statement->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $items[] = $row['itemname'];
        }
        return implode(",", $items);
    }

}