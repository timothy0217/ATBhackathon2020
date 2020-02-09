import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { HashRouter, Route, Switch, Redirect } from 'react-router-dom';
import Home from './Home/Home';
import Main from './Home/Main';
import RegistrationPage from './RegistrationPage/RegistrationPage';
import ResultsPage from './Results/results';
import LoadingToResult from './RegistrationPage/LoadingToResult';
import Login from './Login/Login';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../../sass/app.scss';
import Contributions from "./Contributions/Contributions";

class Index extends Component {
    render() {
        return (
            <HashRouter>
                <Switch>
                    <Route exact path='/' component={Home} />
                    <Route exact path='/main' component={Main} />
                    <Route path='/registerPage/' component={RegistrationPage} />
                    <Route path='/resultsPage/' component={ResultsPage} />
                    <Route path='/contributionsPage/' component={Contributions} />
                    <Route path='/loadingToResult/' component={LoadingToResult} />
                    <Route path='/loginPage/' component={Login} />
                    <Redirect to='/' />
                </Switch>
            </HashRouter>
        );
    }
}

ReactDOM.render(<Index />, document.getElementById('index'));
