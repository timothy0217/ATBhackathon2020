import moment from 'moment';
import axios from 'axios';

export default class LimonAPI {
    getFakeCarbonData() {
        // const fakeData = '{"data":{"value_total":-50.45,"carbon_total":5.045000000000001,"sustainability_score":523,"categories":[{"id":29,"title":"Utility services","carbon_multiplier":0.1,"value":125.32,"carbon":50},{"id":30,"title":"Heating","carbon_multiplier":0.1,"value":55.23,"carbon":43},{"id":31,"title":"Electricity","carbon_multiplier":0.1,"value":23.19,"carbon":22},{"id":32,"title":"Natural gas","carbon_multiplier":0.1,"value":43.22,"carbon":85},{"id":36,"title":"Water","carbon_multiplier":0.1,"value":99.21,"carbon":22},{"id":37,"title":"Other utility expenses","carbon_multiplier":0.1,"value":87.94,"carbon":49},{"id":38,"title":"Transportation","carbon_multiplier":0.1,"value":156.3,"carbon":21},{"id":42,"title":"Fuel","carbon_multiplier":0.1,"value":278.93,"carbon":5.045000000000001},{"id":47,"title":"Vehicle purchase, maintenance","carbon_multiplier":0.1,"value":150.44,"carbon":32},{"id":50,"title":"Accommodation, travel expenses","carbon_multiplier":0.1,"value":430.43,"carbon":88}]}}';

        axios.post('/api/login', {
            email: localStorage.getItem('email')
        }).then(loginResult => {
            axios.get('/api/accounts/' + loginResult.data.data.account_list[0].account_nr + '/score').then(scoreResult => {
                localStorage.setItem('score_result', JSON.stringify(scoreResult.data.data));
            });
        });

        const scoreResult = JSON.parse(localStorage.getItem('score_result'));
        const categories = scoreResult.categories;
        const categoriesArray = Object.keys(categories).map(i => categories[i]);

        categoriesArray.forEach(category => {
            if(category.title === 'Vehicle purchase, maintenance') {
                const newCarbon = (category.carbon / 12) / 10;
                category.carbon = newCarbon;
                category.value = (category.value / 12) / 10;
                category.title = 'Vehicle purchase, maintenance (10 Years)';
            }
        });
        scoreResult.categories = categoriesArray;

        return scoreResult;
    }

    getAccountData() {
        // const fakeData = '{"account_nr":"4052011466999-738eac95-152","holder_name":"Mike Allan","holder_id":"4052011466999-738eac95-152","bank_name":"screaming lemon","currency":"CAD","start_balance":500000,"end_balance":400000,"debit_turnover":101000,"credit_turnover":1000,"period_start":"2020-02-08","period_end":"2020-02-08","transaction_list":[{"date":"2020-02-08","partner":"RRSP Contribution Interest","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id1","sum":2.86},{"date":"2020-02-08","partner":"RRSP Contribution Interest","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id2","sum":2.75},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id3","sum":3.27},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id4","sum":3.31},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id5","sum":3.51},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id6","sum":3.42},{"date":"2020-02-08","partner":"Kid items paid for by Dad","info":"Fee Bank Draft  CAD","transaction_id":"arbritary-unique-id7","sum":-7.5},{"date":"2020-02-08","partner":"UNCATEGORIZED","info":"Bank Draft  CAD","transaction_id":"arbritary-unique-id8","sum":-14641.01},{"date":"2020-02-08","partner":"Kid items paid for by Dad","info":"Fee Bank Draft  CAD","transaction_id":"arbritary-unique-id9","sum":-7.55},{"date":"2020-02-08","partner":"UNCATEGORIZED","info":"Bank Draft  CAD","transaction_id":"arbritary-unique-id10","sum":-14697.76},{"date":"2020-02-08","partner":"Investment Income","info":"Savings Incentive Credit  CAD","transaction_id":"arbritary-unique-id11","sum":13.29},{"date":"2020-02-08","partner":"Investment Income","info":"Savings Incentive Credit  CAD","transaction_id":"arbritary-unique-id12","sum":13.48},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id13","sum":3.37},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id14","sum":3.38},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id15","sum":3.06},{"date":"2020-02-08","partner":"Investment Income","info":"Savings Incentive Credit  CAD","transaction_id":"arbritary-unique-id16","sum":12.73},{"date":"2020-02-08","partner":"Investment Income","info":"Savings Incentive Credit  CAD","transaction_id":"arbritary-unique-id17","sum":12.62},{"date":"2020-02-08","partner":"DIVIDEND_CAP_GAINS","info":"Interest Investment  CAD","transaction_id":"arbritary-unique-id18","sum":3.09},{"date":"2020-02-08","partner":"Sandi\'s RRsp Account","info":"Registered Plan Contribution  CAD","transaction_id":"arbritary-unique-id19","sum":16639.89},{"date":"2020-02-08","partner":"Sandi\'s RRsp Account","info":"Registered Plan Contribution  CAD","transaction_id":"arbritary-unique-id20","sum":16407.88},{"date":"2020-02-08","partner":"Sandi\'s RRsp Account","info":"Registered Plan Contribution  CAD","transaction_id":"arbritary-unique-id21","sum":16608.35},{"date":"2020-02-08","partner":"Sandi\'s RRsp Account","info":"Registered Plan Contribution  CAD","transaction_id":"arbritary-unique-id22","sum":16157.17},{"date":"2020-02-08","partner":"Sandi\'s RRsp Account","info":"Registered Plan Contribution  CAD","transaction_id":"arbritary-unique-id23","sum":16552.69},{"date":"2020-02-08","partner":"Sandi\'s RRsp Account","info":"Registered Plan Contribution  CAD","transaction_id":"arbritary-unique-id24","sum":16248.65}]}';
        axios.post('/api/login', {
            email: localStorage.getItem('email')
        }).then(result => {
            localStorage.setItem('account_details', JSON.stringify(result.data.data));
        });

        const accountData = JSON.parse(localStorage.getItem('account_details'));
        return accountData.account_list[0];
    }

    getSustainabilityPercentage() {
        const fakeData = this.getFakeCarbonData();
        const sustainabilityScore = fakeData.sustainability_score;
        const sustainabilityPercentage = sustainabilityScore / 1000;
        return sustainabilityPercentage.toFixed(2);
    }

    getDonutChartLabels() {
        const categories = this.getFakeCarbonData().categories;
        const categoriesArray = Object.keys(categories).map(i => categories[i]);
        const labels = [];

        categoriesArray.forEach(category => {
            labels.push(category.title);
        });

        return labels;
    }

    getDonutChartData() {
        const categories = this.getFakeCarbonData().categories;
        const categoriesArray = Object.keys(categories).map(i => categories[i]);
        const data = [];

        categoriesArray.forEach(category => {
            data.push(category.carbon);
        });

        return data;
    }

    getBarChartLabels() {
        const categories = this.getFakeCarbonData().categories;
        console.log('bar chart categories', categories);
        const categoriesArray = Object.keys(categories).map(i => categories[i]);
        const labels = [];

        categoriesArray.forEach(category => {
            labels.push(category.title);
        });

        return labels;
    }

    getBarChartData() {
        const categories = this.getFakeCarbonData().categories;
        const categoriesArray = Object.keys(categories).map(i => categories[i]);
        const data = [];

        categoriesArray.forEach(category => {
            data.push(category.value);
        });

        return data;
    }

    getTransactionTableData() {
        const accountData = this.getAccountData();
        const transactions = accountData.transaction_list;

        function createData(date, name, sum, transactionID) {
            return { date, name, sum, transactionID };
        }

        const rows = [];

        transactions.forEach(transaction => {
            const date = moment(transaction.date).format('dddd, MMMM Do YYYY');
            const amount = transaction.sum + ' (' + accountData.currency + ')';

            rows.push(
                createData(date, transaction.info, amount, transaction.transaction_id)
            );
        });

        return rows;
    }
}
