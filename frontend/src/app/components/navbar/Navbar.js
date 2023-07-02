import {useRef} from 'react'
import {Link} from "react-router-dom";
import { useDispatch, useSelector } from 'react-redux';
import { isMobile } from "react-device-detect";
import {logoutAuthSession} from '../../redux/actions/auth'
import searchIcon from "../../../assets/images/icons/search-icon.png"
import settingIcon from "../../../assets/images/icons/setting-icon.png"
import logoutIcon from "../../../assets/images/icons/logout.png"

const Navbar = () => {
    //refs
    const burgerButtonRef = useRef()
    const navLinkRef = useRef()

    //dispatcher
    const dispatch = useDispatch()

    //selectors
    const articleCategories = useSelector(state => state.articleCategory.articleCategories)

    //functions
    const burgerButtonClickHandler = () => {
        const nav = navLinkRef.current
        // Toggle Nav
        nav.classList.toggle('nav-active');

        const navLinks = document.querySelectorAll('.nav-links li');
        //Animate Links
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 +
                0.4}s`;
            }
        });

        // Burger Animation
        burgerButtonRef.current.classList.toggle('toggle');
    }

    const logoutHandler = () => {
        navbarOptionClickHandler()
        dispatch(logoutAuthSession())
    }

    const navbarOptionClickHandler = () => {
        if (isMobile) {
            burgerButtonClickHandler()
        }
    }

    return (
        <header className="default-navbar" role="banner">
            <section className="nav-section">
                {/* <!-- Logo --> */}
                <div className="logo">
                    <Link to="/news-feed">THE NEWS</Link>
                </div>
        
                {/* <!-- Navigation --> */}
                <nav className="nav-menu" role="navigation">
                    <ul className="nav-links" ref={navLinkRef}>
                        <div className='nav-link-section'>
                            {/* <li><Link to="/news-feed" onClick={navbarOptionClickHandler}>Home</Link></li>
                            {
                                articleCategories?.length && articleCategories.map((articleCategory, index) => {
                                    const {name} = articleCategory
                                    const url = `/category/${name.toLowerCase()}`
                                    return (
                                        <li key={index}><a href={url} title={name} onClick={navbarOptionClickHandler}>{name}</a></li>
                                    )
                                })
                            } */}
                        </div>
                        <div className='nav-link-section'>
                            <li className='custom-navbar-button setting-button'>
                                <Link to="/search" onClick={navbarOptionClickHandler}>
                                    <img src={searchIcon} />
                                    <span className="option-name">Search</span>
                                </Link>
                            </li>
                            <li className='custom-navbar-button setting-button'>
                                <Link to="/setting" onClick={navbarOptionClickHandler}>
                                    <img src={settingIcon} />
                                    <span className="option-name">Setting</span>
                                </Link>
                            </li>
                            <li className='custom-navbar-button logout-button'>
                                <a onClick={logoutHandler}>
                                    <img src={logoutIcon} />
                                    <span className="option-name">Logout</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                    <div className="burger" onClick={burgerButtonClickHandler} ref={burgerButtonRef}>
                        <div className="line-1"></div>
                        <div className="line-2"></div>
                        <div className="line-3"></div>
                    </div>
                </nav>
            </section> 
        </header>
    )
}

export default Navbar