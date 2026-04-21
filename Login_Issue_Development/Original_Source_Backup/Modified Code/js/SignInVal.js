 $(document).ready(function() {
            $('#loginForm').bootstrapValidator({
                message: 'This value is not valid',

                fields: {
                    username: {
                        message: 'The username is not valid',
                        validators: {
                            notEmpty: {
                                message: 'This field is Required'
                            }

                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'This field is required'
                            },
                            emailAddress: {
                                message: 'Email address not valid'
                            }
                        }
                    },
                    password: {
                        validators: {
                            /*notEmpty: {
                                message: 'This field is required'
                            },*/
                            /*different: {
                                field: 'username',
                                message: 'The password can\'t be the same as username'
                            },*/
                            callback: {
                                callback: function(value, validator) {
                                    
                                    if (value == "") {
                                        return {
                                            valid: false,
                                            message: 'This field is required'
                                        }
                                    }
                                    if (value === value.toLowerCase()) {
                                        return {
                                            valid: false,
                                            message: 'Atleast one capital letter'
                                        }
                                    }
                                    if (value.search(/[0-9]/) < 0) {
                                        return {
                                            valid: false,
                                            message: 'Atleast one number'
                                        }
                                    }
                                    if (value.length < 8) {
                                        return {
                                            valid: false,
                                            message: 'Atleast 8 characters'
                                        }
                                    }
                                    if (value.search(/[0-9]/) < 0) {
                                        return {
                                            valid: false,
                                            message: 'Atleast one special character'
                                        }
                                    }

                                    return true;
                                }
                            }
                        }
                    } 
                }
            });
        });