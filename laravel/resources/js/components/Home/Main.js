import React, { Component } from 'react';
import axios from 'axios';
import Button from '@material-ui/core/Button';
import { Link } from 'react-router-dom';
import '../../../sass/helpers.scss';
import '../../../sass/Main.scss';
import  '../../../images/APP.png';
import  '../../../images/SAVING_TOGETHER.png';
import  '../../../images/TARGET.png';
import Slider from 'infinite-react-carousel';

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
        const settings = {
            arrows: false,
            arrowsBlock: false,
            duration: 13,
            dots: true,
            pauseOnHover: false,
        };

        return (
            <div>
                <Slider {...settings}>
                    <div>
                        <img className="firstImage" src='../../../../images/APP.png' alt="picture" />
                    </div>
                    <div>
                        <img className="secondImage" src='../../../../images/TARGET.png' alt="picture" />
                    </div>
                    <div>
                        <img className="thirdImage" src='../../../../images/SAVING_TOGETHER.png' alt="picture" />
                    </div>
                    <div>
                        <Link to="/registerPage/" className="btn btn-primary rightAlign">
                            <Button className="nextBtn"><p className="text-black pBtn">Get Started</p></Button>
                        </Link>
                    </div>
                </Slider>
            </div>

        );
    }
}
