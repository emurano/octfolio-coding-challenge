import React, {useState, useEffect} from 'react';
import axios from "axios";
import TransactionTable from "../transaction-table";

const TransactionReport = props => {

    const [data, setData] = useState({
        paging: {
            currentPage: 1,
            numPages: 0,
            numRecords: 0,
            pageSize: 10
        },
        records: []
    });

    const [isLoading, setIsLoading] = useState(false);
    const [searchText, setSearchText] = useState('');

    const fetchTableData = (page, pageSize, searchText) => {
        if (isLoading) return;
        setIsLoading(true);
        const fetchData = async () => {
            let dataUrl = props.dataurl;
            dataUrl += '?pageSize=' + encodeURIComponent(pageSize);
            dataUrl += '&page=' + encodeURIComponent(page);
            if (searchText && searchText.length > 0) {
                dataUrl += '&searchText=' + encodeURIComponent(searchText);
            }
            const result = await axios(dataUrl);
            setData(result.data);
            setIsLoading(false);
        };
        fetchData();
    };

    useEffect(() => {
        fetchTableData(
            data.paging.currentPage,
            data.paging.pageSize,
            searchText
        );
    }, []);

    return <TransactionTable
        loading={isLoading}
        pageSize={data.paging.pageSize}
        page={data.paging.currentPage}
        totalRecords={data.paging.numRecords}
        onPageChange={(newPage) => fetchTableData(newPage, data.paging.pageSize, searchText)}
        onPageSizeChange={(newPageSize) => fetchTableData(1, newPageSize, searchText)}
        onSearch={(newSearchText) => {
            setSearchText(newSearchText);
            fetchTableData(1, data.paging.pageSize, newSearchText);
        }}
        records={data.records}
    />;
}

export default TransactionReport;