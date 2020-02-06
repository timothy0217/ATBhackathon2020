import React, {Component} from 'react';
import axios from 'axios';
import Button from 'react-bootstrap/Button';
import { Link } from 'react-router-dom';

export default class RegistrationPage extends Component {
    constructor(props) {
     super(props);
    }

    render() {
        return (
            <div>
                <h1>This is Page 1</h1>
                <Link to="/PassionPage/"><Button>Go to Passion Page!</Button></Link>
            </div>
        );
    }
}
