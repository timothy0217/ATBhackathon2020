import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { HashRouter, Route, Switch, Redirect } from 'react-router-dom';
import Main from './Home/Main';
import RegistrationPage from './RegistrationPage/RegistrationPage';
import PassionPage from './Passions/passions';
import ResultsPage from './Results/results';
import 'bootstrap/dist/css/bootstrap.min.css';

class Index extends Component {
    render() {
        return (
            <HashRouter>
                <Switch>
                    <Route exact path='/' component={ Main } />
                    <Route path='/registerPage/' component={ RegistrationPage } />
                    <Route path='/passionPage/' component={ PassionPage }/>
                    <Route path='/resultsPage/' component={ ResultsPage }/>
                    <Redirect to='/' />
                </Switch>
            </HashRouter>
        );
    }
}

ReactDOM.render(<Index />, document.getElementById('index'));
