import React, {useState} from 'react';
import styles from "./TransactionTable.module.css";

const pageSizeOptions = [ 10, 20, 50 ];

const TransactionTable = (props) => {

    const {
        loading,
        pageSize,
        records,
        page,
        totalRecords,
        onSearch,
        onPageChange,
        onPageSizeChange,
    } = props;

    const [searchText, setSearchText] = useState('');

    const firstRecordNumber = ((parseInt(page) - 1 ) * pageSize) + 1;
    const lastRecordNumber = parseInt(page) * pageSize;
    const numPages = Math.floor(totalRecords / pageSize);

    return (
        <div className={loading ? styles.Loading : null}>
            <div className={styles.TopRow}>
                <div>
                    <span>Show</span>
                    <select
                        value={pageSize}
                        onChange={(e) => onPageSizeChange(parseInt(e.target.value))}>
                        {pageSizeOptions.map(value => (
                            <option value={value}>{value}</option>
                        ))}
                    </select>
                    <span>entries</span>
                </div>

                <div>
                    <label>Search: </label>
                    <input
                        type="text"
                        value={searchText}
                        onChange={(e) => setSearchText(e.target.value)}
                        onKeyDown={(e) => (e.key === 'Enter') ? onSearch(searchText) : null}/>
                    <button
                        type="button"
                        onClick={() => onSearch(searchText)}>Go</button>
                </div>
            </div>

            <table className={styles.TransactionTable}>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Start Time</th>
                    <th>Finish Time</th>
                    <th>Notes</th>
                    <th>Items</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tfoot></tfoot>
                <tbody>
                {loading &&
                [...Array(10)].map((e, i) => {
                    return (
                        <tr>
                            <th>&nbsp;</th>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    );
                })}
                {!loading && records.map(row => (
                    <tr>
                        <th>{row.id}</th>
                        <td>{row.startTime}</td>
                        <td>{row.finishTime}</td>
                        <td>{row.notes}</td>
                        <td>{row.items}</td>
                        <td>{row.firstName}</td>
                        <td>{row.lastName}</td>
                        <td>{row.role}</td>
                    </tr>
                ))}
                </tbody>
            </table>

            <div className={styles.BottomRow}>
                {!loading &&
                <span>
                    Showing {firstRecordNumber}
                    &nbsp;to {lastRecordNumber}
                    &nbsp;of {totalRecords}
                    {totalRecords == 1 ? ' entry' : ' entries'}
                    </span>
                }
                {loading && <div></div>}

                <div className={styles.Paging}>
                    {page != 1 &&
                        <>
                            <button
                                type="button"
                                onClick={(e) => onPageChange(1)}>First</button>

                            <button
                                type="button"
                                onClick={(e) => onPageChange(Number(page) - 1)}>Previous</button>

                        {[...Array(Math.min(5, Math.max(1, page - 5)) + 1).keys()].slice(page).map(p => (
                            <button
                                type="button"
                                onClick={(e) => onPageChange(p)}>{p}</button>
                        ))}

                        </>
                    }

                    <span>{page}</span>

                    {page != numPages &&
                    <>
                        <button
                            type="button"
                            onClick={(e) => onPageChange(Number(page) + 1)}>Next
                        </button>

                        <button
                            type="button"
                            onClick={(e) => onPageChange(numPages)}>Last</button>
                    </>
                    }
                </div>
            </div>
        </div>
    );
};

export default TransactionTable;
