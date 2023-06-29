import {useState} from 'react'
import {Link, useNavigate} from "react-router-dom";
import { signUpApi } from "../../api/auth";
import formConstants from "../../constants/formConstants.json"
import messages  from "../../constants/messages.json"
import { replaceString } from '../../utils/textUtility';
import { isValidEmail } from '../../utils/validation';
import { fieldUpdateHandler } from './helper/formHelper';

const Signup = () => {
    //navigation hooks
    const navigate = useNavigate();

    //states
    const [email, setEmail] = useState()
    const [emailError, setEmailError] = useState('')
    const [firstName, setFirstName] = useState('')
    const [firstNameError, setFirstNameError] = useState('')
    const [lastName, setLastName] = useState('')
    const [lastNameError, setLastNameError] = useState('')
    const [password, setPassword] = useState('')
    const [passwordError, setPasswordError] = useState('')
    const [confirmPassword, setConfirmPassword] = useState('')
    const [confirmPasswordError, setConfirmPasswordError] = useState('')

    //constants
    const {minPasswordLength} = formConstants
    const {required: requiredErrors, validations: validationsErrors, signUp: signUpErrors} = messages.errors
    const {signUp} = messages.messages
    
    //functions
    const isValidForm = () => {
        return (
            (
                email && firstName && lastName && password?.length >= minPasswordLength
            ) &&
            (
                !emailError && !firstNameError && !lastNameError && !passwordError && !confirmPasswordError
            )
        )
    }

    const validateForm = () => {
        if (!email) {
            setEmailError(requiredErrors.email)
        } else if (!isValidEmail(email)) {
            setEmailError(validationsErrors.invalidEmail)
        }

        if (!firstName) {
            setFirstNameError(requiredErrors.firstName)
        }
        if (!lastName) {
            setLastNameError(requiredErrors.lastName)
        }

        if (!password) {
            setPasswordError(requiredErrors.password)
        } else if (password && password.length < minPasswordLength) {
            setPasswordError(
                replaceString(validationsErrors.minimumPasswordLength, minPasswordLength)
            )
        } else if (password && password !== confirmPassword) {
            setConfirmPasswordError(validationsErrors.confirmPasswordNotMatch)
        } else {
            setConfirmPasswordError("")
        }
    }

    const formSubmitHandler = async(e) => {
        validateForm()
        if (isValidForm()) {
            await signUpApi({
                email,
                first_name: firstName,
                last_name: lastName,
                password
            }).then(response => {
                alert(
                    replaceString(signUp.success, `${firstName} ${lastName}`)
                )
                navigate("/login")
            }).catch(e => {
                const message = e?.response?.data?.message || signUpErrors.fail
                alert(message)
            })
        }
    }

    return (
        <div className="login-body">
            <div className="login-index">
                <div className="login-box">
                    <h1 className="login-title">Sign Up</h1>
                </div>
                <p className="login-desc">Create a new user</p>
            </div>
            <div className="email">
                <label className="box-email">
                    <span className="text-email">E-mail</span>
                    <div className="email-block">
                        <input
                            id="field-email"
                            className={`input-field input-email ${emailError ? "input-error" : ""}`}
                            type="email"
                            placeholder="Enter e-mail"
                            value={email}
                            onChange={event => fieldUpdateHandler(
                                    event.target.name,
                                    event.target.value,
                                    setEmail,
                                    setEmailError
                                )
                            }
                        />
                          <span className="error-message">{emailError ? emailError : ""}</span>  
                    </div>
                </label>
            </div>
            <div className="row row-field">
                <div className="col-md-6 col-12 col-field">
                    <div className="text">
                        <label className="box-text">
                            <span className="text-text">First name</span>
                            <div className="text-block">
                                <input
                                    id="field-first-name"
                                    className={`input-field input-text ${firstNameError ? "input-error" : ""}`}
                                    type="text"
                                    placeholder="Enter first name"
                                    value={firstName}
                                    onChange={event => fieldUpdateHandler(
                                            event.target.name,
                                            event.target.value,
                                            setFirstName,
                                            setFirstNameError
                                        )
                                    }
                                />
                                    <span className="error-message">{firstNameError ? firstNameError : ""}</span>  
                            </div>
                        </label>
                    </div>
                </div>
                <div className="col-md-6 col-12 col-field">
                    <div className="text">
                        <label className="box-text">
                            <span className="text-text">Last name</span>
                            <div className="text-block">
                                <input
                                    id="field-last-name"
                                    className={`input-field input-text ${lastNameError ? "input-error" : ""}`}
                                    type="text"
                                    placeholder="Enter last name"
                                    value={lastName}
                                    onChange={event => fieldUpdateHandler(
                                            event.target.name,
                                            event.target.value,
                                            setLastName,
                                            setLastNameError
                                        )
                                    }
                                />
                                    <span className="error-message">{lastNameError ? lastNameError : ""}</span>  
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div className="password">
                <label className="box-password">
                    <span className="text-password">Password</span>
                    <div className="password-block">
                        <input
                            id="field-password"
                            className={`input-field input-password ${passwordError ? "input-error" : ""}`}
                            type="password"
                            placeholder="Enter password"
                            value={password}
                            onChange={event => fieldUpdateHandler(
                                    event.target.name,
                                    event.target.value,
                                    setPassword,
                                    setPasswordError
                                )
                            }
                        />
                            <span className="error-message">{passwordError ? passwordError : ""}</span>  
                    </div>
                </label>
            </div>
            <div className="password">
                <label className="box-password">
                    <span className="text-password">Confirm Password</span>
                    <div className="password-block">
                        <input
                            id="field-confirm-password"
                            className={`input-field input-password ${confirmPasswordError ? "input-error" : ""}`}
                            type="password"
                            placeholder="Enter confirm password"
                            value={confirmPassword}
                            onChange={event => fieldUpdateHandler(
                                    event.target.name,
                                    event.target.value,
                                    setConfirmPassword,
                                    setConfirmPasswordError
                                )
                            }
                        />
                            <span className="error-message">{confirmPasswordError ? confirmPasswordError : ""}</span>  
                    </div>
                </label>
            </div>
            <div className="footer">
                <button className="button" onClick={formSubmitHandler}>Sign up</button>
                <span className="register">
                    Already have an account? 
                    <Link to="/login">
                        <b>Login</b>
                    </Link>
                </span>
            </div>
        </div>
    )
}
export default Signup