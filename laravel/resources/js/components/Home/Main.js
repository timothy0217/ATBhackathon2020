import React, {Component} from 'react';
import axios from 'axios';
import Button from 'react-bootstrap/Button';
import { Link } from 'react-router-dom';
import '../../sass/helpers.scss';

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
            <div>
                API Response Success: { this.state.apiSuccess }
                <br/>
                <br/>
               <Link to="/registerPage/" className="btn btn-primary"><Button>React Bootstrap Works!</Button></Link>
            </div>
        );
    }
}
