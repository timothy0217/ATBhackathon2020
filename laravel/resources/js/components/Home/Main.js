import React, { Component } from 'react';
import axios from 'axios';
import Button from '@material-ui/core/Button';
import { Link } from 'react-router-dom';
import '../../../sass/helpers.scss';
import '../../../sass/Main.scss';
import '../../../images/APP.png';
import '../../../images/SAVING_TOGETHER.png';
import '../../../images/TARGET.png';
import Slider from 'infinite-react-carousel';
import { Container } from '@material-ui/core';

export default class Main extends Component {
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

            <Container class="mainPage">
                 <div class="topContainer"><Link to="/home/"><img class="homeImg" src="../../../images/Word_Mark.png"></img></Link></div>
                <div class="firstContainer">
                    <img className="firstImage" src='../../../../images/APP.png' alt="picture" />
                    <div class="firstTextContainer">
                        <h2 class="firstTitle">Our mission</h2>
                        <p class="firstparagraph">We know that climate change and sustainability are some of the most pressing 
                        issues of our time. How can a single person help create a greener future?
                        <br/><br/>
                        We believe that small but effective changes to our lifestyles and spending 
                        habits will have positive and long-lasting environmental impacts. 
                        With Limón, we hope to empower and inspire people by showing them how their individual actions 
                        will help save the world.
                        <br/><br/>
                        Limon is a tool that helps you monitor and improve your environmental impact. 
                        We make it easy for you to visualize your carbon footprint and understand how your everyday actions can 
                        impact the environment.
                        </p>
                    </div>
                </div>
                <br />
                <br />
                <div class="secondContainer">
                    <img className="secondImage" src='../../../../images/SAVING_TOGETHER.png' alt="picture" />
                    <div class="secondTextContainer">
                        <h2 class="secondTitle">Connect your accounts</h2>
                        <p class="secondparagraph">After you connect Limón to your financial accounts, we’ll take care of the hard part:
                        <br/>
                        <br/>
                        -      Evaluating your environmental impact by analyzing your spending habits and giving you a sustainability score (i)
                        <br/>
                        -      Delivering valuable insights in an easy-to-understand dashboard.</p>
                    </div>
                </div>
                <br />
                <div class="thirdContainer">
                    <img className="thirdImage" src='../../../../images/TARGET.png' alt="picture" />
                    <div class="thirdTextContainer">
                        <h2 class="thirdTitle">Know thyself</h2>
                        <p class="thirdparagraph">Once you know your sustainability score and explore the dashboard, 
                        you’ll know how your spending and consumption affects your community and the planet. 
                        Your sustainability score will constantly be updated, so you can see what changes you make in your lifestyle 
                        and spending are helping to improve your rating.</p>
                    </div>
                </div>
                <div id="backToHomeBtn"><Link to="/home/"><Button id="bckBtn" className="btn btn-primary">Back to Home</Button></Link></div>
    
            </Container>
        );
    }
}
