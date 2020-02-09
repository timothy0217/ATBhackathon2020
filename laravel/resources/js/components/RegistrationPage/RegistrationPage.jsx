import React, {Component} from 'react';
import {Container, Typography, TextField, Button, Grid, Select, MenuItem} from '@material-ui/core';
import '../../../sass/RegistrationPage.scss';

export default class RegistrationPage extends Component {
    constructor(props) {
        super(props);

        // Set the initial state for the form elements to empty values
        this.state = {
            'first_name': '',
            'last_name': '',
            'email': '',
            'street_address': '',
            'unit_number': '',
            'city': '',
            'province': 'Alberta',
            'country': 'Canada',
        };
    }

    updateFormState(event) {
        const obj  = {};
        obj[event.target.id] = event.target.value;
        this.setState(obj);
    }

    handleFormSubmit() {
        localStorage.setItem('first_name', this.state.first_name);
        localStorage.setItem('last_name', this.state.last_name);
        localStorage.setItem('email', this.state.email);
        localStorage.setItem('street_address', this.state.street_address);
        localStorage.setItem('unit_number', this.state.unit_number);
        localStorage.setItem('city', this.state.city);
        localStorage.setItem('province', this.state.province);
        localStorage.setItem('country', this.state.country);

        // Redirect to next page
        this.props.history.push('/passionPage');
    }

    render() {
        return (
            <Container>
                <div className="form-container">
                    <Typography variant="h4">
                        Let's get to know each other
                    </Typography>
                    <br /><br />

                    <form noValidate autoComplete="off">
                        <Grid container spacing={3}>
                            <Grid item xs={12} md={6}>
                                <TextField id="first_name" label="First Name" variant="filled" fullWidth
                                           onChange={this.updateFormState.bind(this)} />
                            </Grid>
                            <Grid item xs={12} md={6}>
                                <TextField id="last_name" label="Last Name" variant="filled" fullWidth
                                           onChange={this.updateFormState.bind(this)}/>
                            </Grid>
                        </Grid>
                        <TextField id="email" label="Email" variant="filled" fullWidth
                                   onChange={this.updateFormState.bind(this)}/>
                        <br />
                        <Grid container spacing={3}>
                            <Grid item xs={12} md={8}>
                                <TextField id="street_address" label="Street Address" variant="filled" fullWidth
                                           onChange={this.updateFormState.bind(this)}/>
                            </Grid>
                            <Grid item xs={12} md={4}>
                                <TextField id="unit_number" label="Unit Number" variant="filled" fullWidth
                                           onChange={this.updateFormState.bind(this)}/>
                            </Grid>
                        </Grid>
                        <Grid container spacing={3}>
                            <Grid item xs={12} md={4}>
                                <TextField id="city" label="City" variant="filled" fullWidth
                                           onChange={this.updateFormState.bind(this)}/>
                            </Grid>
                            <Grid item xs={12} md={4}>
                                <Select id="province" label="Province" variant="filled" fullWidth value="AB">
                                    <MenuItem value="AB" className="select-option">Alberta</MenuItem>
                                </Select>
                            </Grid>
                            <Grid item xs={12} md={4}>
                                <Select id="country" label="Country" variant="filled" fullWidth value="CA">
                                    <MenuItem value="CA" className="select-option">Canada</MenuItem>
                                </Select>
                            </Grid>
                        </Grid>

                        <center>
                            <Button className="btn btn-primary submit" disableElevation onClick={() => this.handleFormSubmit()}>
                                Submit
                            </Button>
                        </center>
                    </form>
                </div>
            </Container>
        );
    }
}
