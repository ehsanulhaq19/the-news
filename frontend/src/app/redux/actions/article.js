import { setArticles } from "../reducers/article"
import { getArticleCollectionApi } from "../../api/article"

export const fetchArticlesAction = () => (dispatch) => {
    return getArticleCollectionApi()
            .then(response => {
                const {data} = response
                dispatch(setArticles(data.articles))
                return response
            })
}

export const setArticlesAction = (articles) => (dispatch) => {
    dispatch(setArticles(articles))
}