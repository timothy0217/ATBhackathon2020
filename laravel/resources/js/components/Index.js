import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch, Redirect } from 'react-router-dom';
import Main from './Home/Main';
import RegistrationPage from './RegistrationPage/RegistrationPage';
import PassionPage from './Passions/passions';
import 'bootstrap/dist/css/bootstrap.min.css';

class Index extends Component {
    render() {
        return (
            <BrowserRouter>
                <Switch>
                    <Route exact path='/' component={Main} />
                    <Route path='/registerPage/' component={RegistrationPage} />
                    <Route path='/passionPage/' component={PassionPage}/>
                    <Redirect to='/' />
                </Switch>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<Index />, document.getElementById('index'));
