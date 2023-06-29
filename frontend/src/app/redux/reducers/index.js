import { combineReducers } from 'redux'
import auth from "./auth";
import article from "./article";
import articleCategory from "./articleCategory";
import articleAuthor from "./articleAuthor";
import articleSource from "./articleSource";
import userPrefrence from "./userPrefrence"

export default combineReducers({
    auth,
    article,
    articleCategory,
    articleAuthor,
    articleSource,
    userPrefrence
})