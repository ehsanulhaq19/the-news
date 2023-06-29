import { setArticleSources } from "../reducers/articleSource"
import { getArticleSourcesCollectionApi } from "../../api/articleSource"

export const fetchArticleSourcesAction = () => (dispatch) => {
    return getArticleSourcesCollectionApi()
            .then(response => {
                const {data} = response
                dispatch(setArticleSources(data.article_sources))
                return response
            })
}