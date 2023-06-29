import { setArticleCategories } from "../reducers/articleCategory"
import { getArticleCategoriesCollectionApi } from "../../api/articleCategory"

export const fetchArticleCategoriesAction = () => (dispatch) => {
    return getArticleCategoriesCollectionApi()
            .then(response => {
                const {data} = response
                dispatch(setArticleCategories(data.article_categories))
                return response
            })
}