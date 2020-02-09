import React, {Component} from 'react';
import {Bar} from 'react-chartjs-2';
import LimonAPI from "../../classes/LimonAPI";

export default class BarChart extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        const api = new LimonAPI();

        this.setState({
            data: {
                labels: api.getBarChartLabels(),
                datasets: [
                    {
                        label: 'Dollar Value',
                        backgroundColor: '#00C853',
                        borderColor: '#00C853',
                        borderWidth: 1,
                        hoverBackgroundColor: '#00E676',
                        hoverBorderColor: '#00E676',
                        data: api.getBarChartData(),
                    }
                ]
            }
        });
    }

    render() {
        return (<Bar data={this.state.data}/>)
    }
}
