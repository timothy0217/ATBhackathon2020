import React, { Component } from 'react';
// import {CartesianGrid, Line, LineChart, XAxis, YAxis} from "recharts";
import {Line} from 'react-chartjs-2';

export default class DashboardChart extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        this.setState({
            data: {
                labels: [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'October', 'November', 'December',
                ],
                datasets: [
                    {
                        label: 'Stonks',
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: 'rgba(75,192,192,0.4)',
                        borderColor: 'rgba(75,192,192,1)',
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: 'rgba(75,192,192,1)',
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: 'rgba(75,192,192,1)',
                        pointHoverBorderColor: 'rgba(220,220,220,1)',
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [1000, 1400, 2400, 1900, 2600, 2400, 2800, 3100, 3700, 3300, 4000, 5500]
                    }
                ]
            }
        });
    }

    render() {
        return (<Line data={this.state.data} />)
    }
}
