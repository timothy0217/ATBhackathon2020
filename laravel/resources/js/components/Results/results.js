import React, {Component} from 'react';
import Navigation from '../Navigation/Navigation';
import DonutChart from "../Charts/DonutChart";
import BarChart from "../Charts/BarChart";
import clsx from "clsx";
import Typography from "@material-ui/core/Typography";
import {makeStyles} from '@material-ui/core/styles';
import LimonGaugeChart from "../Charts/GaugeChart";
import '../../../sass/Results.scss';
import TransactionsTable from "../Tables/TransactionsTable";

export default function ResultsPage() {
    const drawerWidth = 240;
    const useStyles = makeStyles(theme => ({
        content: {
            flexGrow: 1,
            padding: theme.spacing(3),
            transition: theme.transitions.create('margin', {
                easing: theme.transitions.easing.sharp,
                duration: theme.transitions.duration.leavingScreen,
            }),
            marginLeft: -drawerWidth,
        },
        contentShift: {
            transition: theme.transitions.create('margin', {
                easing: theme.transitions.easing.easeOut,
                duration: theme.transitions.duration.enteringScreen,
            }),
            marginLeft: 0,
        },
    }));
    const classes = useStyles();

    return (
        <React.Fragment>
            <Navigation/>

            <main
                className={clsx(classes.content, {
                    [classes.contentShift]: open,
                })}
            >
                <div className={classes.drawerHeader}/>
                <br/>
                <br/>
                <br/>
                <br/>
                <center>
                    <Typography variant="h4">
                        Sustainability Score
                    </Typography>
                </center>
                <br/>
                <LimonGaugeChart/>
                <br />
                <br />
                <br />
                <br />

                <center>
                    <Typography variant="h4">
                        Total Carbon Footprint
                    </Typography>
                </center>
                <br/>
                <DonutChart/>
                <br />
                <br />
                <br />
                <br />

                <center>
                    <Typography variant="h4">
                        Total Spent
                    </Typography>
                </center>
                <br/>
                <BarChart/>

                <br />
                <br />
                <br />
                <br />

                <center>
                    <Typography variant="h4">
                        Transactions
                    </Typography>
                </center>
                <br/>
                <TransactionsTable/>
            </main>
        </React.Fragment>
    );
}
