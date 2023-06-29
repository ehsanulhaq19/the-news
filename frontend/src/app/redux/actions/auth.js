import { setUser, setToken, logout } from "../reducers/auth"

export const setUserAction = (user) => (dispatch) => {
    dispatch(setUser(user))
}

export const setTokenAction = (token) => (dispatch) => {
    dispatch(setToken(token))
}

export const logoutAuthSession = () => (dispatch) => {
    dispatch(logout())
}