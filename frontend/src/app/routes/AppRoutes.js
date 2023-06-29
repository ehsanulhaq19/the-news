import { BrowserRouter, Routes, Route } from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import UserLayout from "../layouts/UserLayout";
import BlankLayout from "../layouts/BlankLayout";
import Login from '../pages/auth/Login'
import SignUp from '../pages/auth/SignUp'
import NewsFeed from '../pages/newsFeed/NewsFeed'
import Article from "../pages/newsFeed/Article";
import Search from "../pages/newsFeed/Search";
import Setting from "../pages/user/Setting";
import PageNotFound from "../pages/Misc/PageNotFound";
import BlankPage from "../pages/Misc/BlankPage";

const AppRoutes = () => {
    return <BrowserRouter>
        <Routes>
            <Route path="/" element={<AuthLayout />}>
                <Route path="/login" element={<Login /> } />
                <Route path="/signup" element={<SignUp /> } />
            </Route>
            <Route path="/" element={<UserLayout />}>
                <Route path="/news-feed" element={<NewsFeed /> } />
                <Route path="/search" element={<Search /> } />
                <Route path="/article/:category/:id" element={<Article /> } />
                <Route path="/setting" element={<Setting /> } />
            </Route>
            <Route path="/" element={<BlankLayout />}>
                <Route path="/not-found" element={<PageNotFound /> } />
                <Route path="*" element={<BlankPage /> } />
            </Route>
        </Routes>
    </BrowserRouter> 
}

export default AppRoutes