import {useEffect} from "react";
import { Outlet, useLocation, useNavigate } from "react-router-dom";

const BlankLayout = () => {
    //react router hooks
    const location = useLocation()
    const navigate = useNavigate()

    //event hooks
    useEffect(() => {
        const {pathname} = location
        if (pathname !== "/not-found") {
            navigate("/not-found")
        }
    }, [])

    return (
        <div className="blank-layout">
            <div className="content-wrap">
                <Outlet />
            </div>
        </div>
    );
};
export default BlankLayout;