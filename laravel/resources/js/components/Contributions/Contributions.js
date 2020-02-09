import React, {Component} from 'react';
import {Container, Typography, TextField, Button} from '@material-ui/core';
import '../../../sass/RegistrationPage.scss';

export default class Passions extends Component {
    constructor(props) {
        super(props);

        // Set the initial state for the form elements to empty values
        this.state = {
            'contribution_one': '',
            'contribution_two': '',
            'contribution_three': '',
        };
    }

    updateFormState(event) {
        const obj = {};
        obj[event.target.id] = event.target.value;
        this.setState(obj);
    }

    handleFormSubmit() {
        console.log('handle form submit', this.state);
        localStorage.setItem('contribution_one', this.state.contribution_one);
        localStorage.setItem('contribution_two', this.state.contribution_two);
        localStorage.setItem('contribution_three', this.state.contribution_three);

        console.log('local storage', Object.entries(localStorage));

        // Redirect to next page
        // TODO: Redirect to loading page
        this.props.history.push('/resultsPage');
    }

    render() {
        return (
            <div className="form-container">
                <Typography variant="h4">
                    Set Your Contributions
                </Typography>
                <br/><br/>

                <form noValidate autoComplete="off" className="form-inner">
                    <TextField id="contribution_one" label="Contribution 1" variant="filled" fullWidth
                               onChange={this.updateFormState.bind(this)}/>
                    <br/>
                    <TextField id="contribution_two" label="Contribution 2" variant="filled" fullWidth
                               onChange={this.updateFormState.bind(this)}/>
                    <br/>
                    <TextField id="contribution_three" label="Contribution 3" variant="filled" fullWidth
                               onChange={this.updateFormState.bind(this)}/>
                    <br/>

                    <center>
                        <Button className="btn btn-primary submit"
                                disableElevation
                                onClick={() => this.handleFormSubmit()}
                        >
                            Submit
                        </Button>
                    </center>
                </form>
            </div>
        );
    }
}
