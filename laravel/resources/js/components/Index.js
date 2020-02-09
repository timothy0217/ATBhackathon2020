import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { HashRouter, Route, Switch, Redirect } from 'react-router-dom';
import Home from './Home/Home';
import Main from './Home/Main';
import RegistrationPage from './RegistrationPage/RegistrationPage';
import PassionPage from './Passions/passions';
import ResultsPage from './Results/results';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../../sass/app.scss';

class Index extends Component {
    render() {
        return (
            <HashRouter>
                <Switch>
                    <Route exact path='/' component={Home} />
                    <Route exact path='/main' component={Main} />
                    <Route path='/registerPage/' component={RegistrationPage} />
                    <Route path='/passionPage/' component={PassionPage} />
                    <Route path='/resultsPage/' component={ResultsPage} />
                    <Redirect to='/' />
                </Switch>
            </HashRouter>
        );
    }
}

ReactDOM.render(<Index />, document.getElementById('index'));
