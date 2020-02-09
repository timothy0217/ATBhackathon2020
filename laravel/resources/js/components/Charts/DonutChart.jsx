import React, {Component} from 'react';
import {Doughnut} from 'react-chartjs-2';
import LimonAPI from "../../classes/LimonAPI";

export default class DonutChart extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        const api = new LimonAPI();

        this.setState({
            data: {
                labels: api.getDonutChartLabels(),
                datasets: [{
                    data: api.getDonutChartData(),
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#FF6384',
                    ],
                    hoverBackgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#FF6384',
                    ],
                }],
            }
        });
    }

    render() {
        return (<Doughnut data={this.state.data}/>)
    }
}
