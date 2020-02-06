import React, {Component} from 'react';
import axios from 'axios';
import Button from 'react-bootstrap/Button';
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
                <br />
                <Button className="btn btn-primary">React Bootstrap Works!</Button>
            </div>
        );
    }
}
