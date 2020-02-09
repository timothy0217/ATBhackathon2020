export default class Login {
    sendRequest(email) {
        console.log('email', email);
        axios.post('/api/login', {
            email
        }).then(result => {
            console.log('result', result);
            localStorage.setItem('account_details', result.data.data);
        });
    }
}
