import React, {Component} from 'react';
import Navigation from '../Navigation/Navigation';
import DashboardChart from "../Charts/DashboardChart";
import clsx from "clsx";
import Typography from "@material-ui/core/Typography";
import { makeStyles } from '@material-ui/core/styles';

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
                <Navigation />

                <main
                    className={clsx(classes.content, {
                        [classes.contentShift]: open,
                    })}
                >
                    <div className={classes.drawerHeader} />
                    <Typography variant="h4">
                        Your Dashboard
                    </Typography>
                    <br />
                    <DashboardChart />
                </main>
            </React.Fragment>
        );
}
