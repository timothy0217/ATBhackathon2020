import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route} from 'react-router-dom';
import Main from './Main';
import 'bootstrap/dist/css/bootstrap.min.css';

class Index extends Component {
    render() {
        return (
            <BrowserRouter>
                <Route component={Main} />
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<Index />, document.getElementById('index'));
