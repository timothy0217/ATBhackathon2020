import React, {Component} from 'react';
import {Container, Typography, TextField, Button, Grid, Select, MenuItem} from '@material-ui/core';
import '../../../sass/Login.scss';
import { Link } from 'react-router-dom';


export default class LoginPage extends Component {
    constructor(props) {
        super(props);
        // Set the initial state for the form elements to empty values
        this.state = {
            'account_id': '',
            'password': '',
        };
    }
    updateFormState(event) {
        const obj  = {};
        obj[event.target.id] = event.target.value;
        this.setState(obj);
    }
    handleFormSubmit() {
        localStorage.setItem('email', this.state.account_id);
        localStorage.setItem('password', this.state.password);
        console.log('local storage', Object.entries(localStorage));
        // Redirect to next page
        this.props.history.push('/resultsPage');
    }
    render() {
        return (
            <div className="loginmaincontainer">
                <div className="loginLopContainer">
                <div class="topContainer"><Link to="/home/"><img class="homeImg" src="../../../images/Word_Mark.png"></img></Link></div>
                </div>
                <div className="boxContainer">
                    <div className="container">
                        <div className="loginForm">
                            <Typography variant="h4">
                                <b>Login</b>
                            </Typography>
                            <br /><br />
                                <form noValidate autoComplete="off">
                                    <TextField id="email" label="Email" variant="filled" fullWidth onChange={this.updateFormState.bind(this)} />
                                    <br /><br />
                                    <TextField id="password" label="Password" variant="filled" type="password" fullWidth onChange={this.updateFormState.bind(this)}/>
                                    <br /><br />
                                    <center>
                                        <Button className="btn btn-primary submitLogin" disableElevation onClick={() => this.handleFormSubmit()}>
                                            <b>Sign In</b>
                                        </Button>
                                    </center>
                                    <br /><br />
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        );
    }
}