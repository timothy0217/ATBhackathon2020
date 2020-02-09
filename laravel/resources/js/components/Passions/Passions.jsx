import React, {Component} from 'react';
import {Container, Typography, TextField, Button} from '@material-ui/core';
import '../../../sass/RegistrationPage.scss';

export default class Passions extends Component {
    constructor(props) {
        super(props);

        // Set the initial state for the form elements to empty values
        this.state = {
            'passion_one': '',
            'passion_two': '',
            'passion_three': '',
            'passion_four': '',
            'passion_five': '',
        };
    }

    updateFormState(event) {
        const obj  = {};
        obj[event.target.id] = event.target.value;
        this.setState(obj);
    }

    handleFormSubmit() {
        console.log('handle form submit', this.state);
        localStorage.setItem('passion_one', this.state.passion_one);
        localStorage.setItem('passion_two', this.state.passion_two);
        localStorage.setItem('passion_three', this.state.passion_three);
        localStorage.setItem('passion_four', this.state.passion_four);
        localStorage.setItem('passion_five', this.state.passion_five);

        console.log('local storage', Object.entries(localStorage));

        // Redirect to next page
        this.props.history.push('/contributionsPage');
    }

    render() {
        return (
            <Container>
                <div className="form-container">
                    <Typography variant="h4">
                        Just a few more details...
                    </Typography>
                    <br /><br />

                    <form noValidate autoComplete="off">
                        <TextField id="passion_one" label="Passion 1" variant="filled" fullWidth
                                   onChange={this.updateFormState.bind(this)}/>
                        <br />
                        <TextField id="passion_two" label="Passion 2" variant="filled" fullWidth
                                   onChange={this.updateFormState.bind(this)}/>
                        <br />
                        <TextField id="passion_three" label="Passion 3" variant="filled" fullWidth
                                   onChange={this.updateFormState.bind(this)}/>
                        <br />
                        <TextField id="passion_four" label="Passion 4" variant="filled" fullWidth
                                   onChange={this.updateFormState.bind(this)}/>
                        <br />
                        <TextField id="passion_five" label="Passion 5" variant="filled" fullWidth
                                   onChange={this.updateFormState.bind(this)}/>
                        <br />

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
