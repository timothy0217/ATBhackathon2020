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
                <div class="topContainer"><img class="homeImg" src="../../../images/Word_Mark.png"></img>
                    <Link to="/main/"><h5 class="aboutUs">About Us</h5></Link>
                </div>
                <div><img class="lemonLogo" src="../../../images/LOGO.png"></img></div>
                <div class="titleContainer"><h1 class="homeText">Make your green greener</h1></div>
                <div class="textUnderTitle"><p class="firstline"> Form sustainable spending habits with Limón</p></div>
                <div class="btnContainer">
                    <Link to="/registerPage/"><Button id="homeBtn" className="btn btn-primary">Sign Up</Button></Link>
                    <Link to="/loginPage/"><Button id="homeBtn" className="btn btn-primary">Log In</Button></Link>
                </div>
            </div>

        );
    }
}