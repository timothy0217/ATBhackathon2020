import React, {Component} from 'react';
import Button from '@material-ui/core/Button';
import { Link } from 'react-router-dom';
import '../../../sass/LoadingToResult.scss';
import {Container} from "@material-ui/core";

export default class LoadingToResult extends Component {
    constructor(props) {
        super(props);
    }
    
    render() {
        var gif = "laravel/public/images/spinning-lemon.gif";
        return (
            <center>
                <div className="loadingOnly">
                    <br></br>
                    <br></br>
                    <br></br>
                    <br></br>
                    <br></br>
                    <br></br>
                    <br></br>
                    <br></br>
                    <h1>Just a sec...</h1>
                    <h1>We're building your personalized portfolio.</h1>
                    <Link to="/resultsPage/" className="lemonLink"><img src={require('../../../images/spinning-lemon.gif')} alt="Loading...?" /></Link>
                </div>
            </center>
        );
    }
}