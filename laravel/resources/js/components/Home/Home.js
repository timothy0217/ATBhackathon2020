import React, { Component } from 'react';
import axios from 'axios';
import Button from '@material-ui/core/Button';
import { Link } from 'react-router-dom';
import '../../../sass/Home.scss';
import '../../../images/Word_Mark.png';
import '../../../images/LOGO.png';

export default class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            apiSuccess: 'False',
        };
    }

    componentWillMount() {
        axios.get('/api/test/yayitworks').then(result => {
            console.log('Laravel Backend API Result', result.data);
            this.setState({
                apiSuccess: result.data.success
            });
        });
    }

    render() {

        return (
            <div class="homebckground">
                <div><img class="homeImg" src="../../../images/Word_Mark.png"></img></div>
                <div><img class="lemonLogo" src="../../../images/LOGO.png"></img></div>
                <div class="titleContainer"><h1 class="homeText">Make good money.</h1></div>
                <div>
                    <Button>Sign In</Button>
                    <Button>Register</Button>
                </div>
            </div>

        );
    }
}