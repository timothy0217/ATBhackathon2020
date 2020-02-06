import React, {Component} from 'react';
import Button from 'react-bootstrap/Button';
import { Link } from 'react-router-dom';

export default class PassionPage extends Component {
    constructor(props) {
     super(props);
    }

    render() {
        return (
            <div>
                <h1>This is Page 2</h1>
                <Link to="/resultsPage/"><Button>Results Page!</Button></Link>
            </div>
        );
    }
}