import * as React from 'react';
import styles  from "./MainPage.module.css";
import TransactionReport from 'transaction-report';

const MainPage = props => {

    console.log('MainPage props', props);

    return (
        <main className={styles.MainPage}>
            <h1>Transactions</h1>

            <TransactionReport dataurl={props.dataurl}/>
        </main>
    );
};

export default MainPage;