import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import clsx from "clsx";
import Drawer from '@material-ui/core/Drawer';
import CssBaseline from '@material-ui/core/CssBaseline';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import List from '@material-ui/core/List';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import AssessmentIcon from '@material-ui/icons/Assessment';
import EmojiObjectsIcon from '@material-ui/icons/EmojiObjects';
import SettingsIcon from '@material-ui/icons/Settings';
import LiveHelpIcon from '@material-ui/icons/LiveHelp';
import CloseIcon from '@material-ui/icons/Close';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import {Link} from "react-router-dom";

const drawerWidth = 300;

const useStyles = makeStyles(theme => ({
    root: {
        display: 'flex',
    },
    appBar: {
        transition: theme.transitions.create(['margin', 'width'], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
    },
    appBarShift: {
        width: `calc(100% - ${drawerWidth}px)`,
        marginLeft: drawerWidth,
        transition: theme.transitions.create(['margin', 'width'], {
            easing: theme.transitions.easing.easeOut,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    menuButton: {
        marginRight: theme.spacing(2),
    },
    hide: {
        display: 'none',
    },
    drawer: {
        width: drawerWidth,
        flexShrink: 0,
    },
    drawerPaper: {
        width: drawerWidth,
    },
    drawerHeader: {
        display: 'flex',
        alignItems: 'center',
        padding: theme.spacing(0, 1),
        ...theme.mixins.toolbar,
        justifyContent: 'space-between',
    },
}));

export default function Navigation() {
    const classes = useStyles();
    const [open, setOpen] = React.useState(false);

    const handleDrawerOpen = () => {
        setOpen(true);
    };

    const handleDrawerClose = () => {
        setOpen(false);
    };

    return (
        <div className={classes.root}>
            <CssBaseline />
            <AppBar
                position="fixed"
                className={clsx(classes.appBar, {
                    [classes.appBarShift]: open,
                })}
            >
                <Toolbar>
                    <IconButton
                        color="inherit"
                        aria-label="open drawer"
                        onClick={handleDrawerOpen}
                        edge="start"
                        className={clsx(classes.menuButton, open && classes.hide)}
                    >
                        <MenuIcon className="hamburger-icon" />
                    </IconButton>
                    <Typography variant="h6" noWrap>
                        <img className="limon-logo" src="../../../images/logos/wordmark-colour.png" />
                    </Typography>
                </Toolbar>
            </AppBar>
            <Drawer
                className={classes.drawer}
                variant="persistent"
                anchor="left"
                open={open}
                classes={{
                    paper: classes.drawerPaper,
                }}
            >
                <div className={classes.drawerHeader}>
                    <IconButton>
                        <img className="drawer-logo" src="../../../images/logos/logo-slant-greyscale.png" />
                    </IconButton>
                    <IconButton onClick={handleDrawerClose}>
                        <CloseIcon className="drawer-close" />
                    </IconButton>
                </div>
                <List>
                    <Link to="/resultsPage">
                        <ListItem button key="dashboard">
                            <ListItemIcon>
                                <AssessmentIcon />
                            </ListItemIcon>
                            <ListItemText primary="Dashboard" />
                        </ListItem>
                    </Link>
                    <Link>
                        <ListItem button key="insights">
                            <ListItemIcon>
                                <EmojiObjectsIcon />
                            </ListItemIcon>
                            <ListItemText primary="Insights" />
                        </ListItem>
                    </Link>
                    <Link>
                        <ListItem button key="settings">
                            <ListItemIcon>
                                <SettingsIcon />
                            </ListItemIcon>
                            <ListItemText primary="Settings" />
                        </ListItem>
                    </Link>
                    <Link>
                        <ListItem button key="support">
                            <ListItemIcon>
                                <LiveHelpIcon />
                            </ListItemIcon>
                            <ListItemText primary="Support" />
                        </ListItem>
                    </Link>
                </List>
            </Drawer>
        </div>
    );
}
