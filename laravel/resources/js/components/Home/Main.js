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
          
            <Container>
                 <div id="backToHomeBtn"><Link to="/home/"><Button className="btn btn-primary">Back to Home</Button></Link></div>
                <div class="firstContainer">
                    <img className="firstImage" src='../../../../images/APP.png' alt="picture" />
                    <div class="firstTextContainer">
                        <h2 class="firstTitle">Our Mission</h2>
                        <p class="firstparagraph">Lemón is dicated to providing users insightful analytics about
                        their income spending and how it impacts the environment.</p>
                    </div>
                </div>
                <br />
                <div class="secondContainer">
                    <img className="secondImage" src='../../../../images/SAVING_TOGETHER.png' alt="picture" />
                    <div class="secondTextContainer">
                        <h2 class="secondTitle">Connect your accounts</h2>
                        <p class="secondparagraph">Lemón is dicated to providing users insightful analytics about
                        their income spending and how it impacts the environment.</p>
                    </div>
                </div>
                <br />
                <div class="thirdContainer">
                    <img className="thirdImage" src='../../../../images/TARGET.png' alt="picture" />
                    <div class="thirdTextContainer">
                        <h2 class="thirdTitle">Know thyself</h2>
                        <p class="thirdparagraph">Lemón is dicated to providing users insightful analytics about
                        their income spending and how it impacts the environment.</p>
                    </div>
                </div>
                <div>
                </div>
            </Container>
        );
    }
}
