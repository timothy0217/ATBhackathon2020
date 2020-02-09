import React, {Component} from 'react';
import LimonAPI from "../../classes/LimonAPI";
import GaugeChart from 'react-gauge-chart'

export default class LimonGaugeChart extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        const api = new LimonAPI();
        const data = api.getFakeCarbonData();
        const sustainabilityScore = data.sustainability_score;
        const percent = parseFloat(sustainabilityScore) / 1000;

        this.setState({ percent: percent.toFixed(2) });
    }

    render() {
        return (
            <GaugeChart id="gauge-chart2"
                        nrOfLevels={3}
                        colors={['#E63316', '#F2F204', '#00C853']}
                        percent={this.state.percent}
            />
        )
    }
}
