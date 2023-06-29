import {useState} from 'react'
import {Link, useNavigate} from "react-router-dom";
import { useDispatch } from 'react-redux';
import { loginApi } from "../../api/auth";
import formConstants from "../../constants/formConstants.json"
import messages  from "../../constants/messages.json"
import { replaceString } from '../../utils/textUtility';
import { isValidEmail } from '../../utils/validation';
import { fieldUpdateHandler } from './helper/formHelper';
import { setUserAction, setTokenAction } from '../../redux/actions/auth';

const Login = () => {
    //navigation hooks
    const navigate = useNavigate()
    const dispatch = useDispatch()

    //states
    const [email, setEmail] = useState()
    const [emailError, setEmailError] = useState('')
    const [password, setPassword] = useState('')
    const [passwordError, setPasswordError] = useState('')
    
    //constants
    const {minPasswordLength} = formConstants
    const {required: requiredErrors, validations: validationsErrors, login: loginErrors} = messages.errors

    //functions
    const isValidForm = () => {
        return (
            (
                email && password?.length >= minPasswordLength
            ) &&
            (
                !emailError && !passwordError
            )
        )
    }

    const validateForm = () => {
        if (!email) {
            setEmailError(requiredErrors.email)
        } else if (!isValidEmail(email)) {
            setEmailError(validationsErrors.invalidEmail)
        }

        if (!password) {
            setPasswordError(requiredErrors.password)
        } else if (password && password.length < minPasswordLength) {
            setPasswordError(
                replaceString(validationsErrors.minimumPasswordLength, minPasswordLength)
            )
        }
    }

    const formSubmitHandler = async() => {
        validateForm()
        if (isValidForm()) {
            await loginApi({
                email,
                password
            }).then(response => {
                const {data} = response
                dispatch(setUserAction(data.user))
                dispatch(setTokenAction(data.token))
                navigate("/news-feed")
            }).catch(e => {
                console.log("-------error-------", e)
                const message = e?.response?.data?.message || loginErrors.fail
                alert(message)
            })
        }
    }

    return (
        <div className="login-body">
            <div className="login-index">
                <div className="login-box">
                    <h1 className="login-title">Login</h1>
                </div>
                <p className="login-desc">Enter email and password</p>
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
            <div className="footer">
                <button className="button" onClick={formSubmitHandler}>Login</button>
                <span className="register">
                    Don't have an account? 
                    <Link to="/signup">
                        <b>Sign up</b>
                    </Link>
                </span>
            </div>
        </div>
    )
}
export default Login