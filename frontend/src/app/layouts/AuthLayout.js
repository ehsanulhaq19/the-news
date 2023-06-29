import {useEffect} from "react";
import { Outlet, useNavigate } from "react-router-dom";
import { useSelector } from 'react-redux';

const AuthLayout = () => {
    //navigators
    const navigate = useNavigate()
    //selectors
    const authUserToken = useSelector(state => state.auth.token)

    //event cycle hooks
    useEffect(() => {
        if (navigate && authUserToken) {
            navigate("/news-feed")
        }
    }, [navigate, authUserToken])

    return (
        <div className="auth-screen screen">
            <div className="content-left"></div>
            <div className="content-right">
                <div className="logo">
                    {/* <img src="/images/logo.svg" /> */}
                </div>
                <Outlet />
            </div>
        </div>
    );
};
export default AuthLayout;