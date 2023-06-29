import { setArticleAuthors } from "../reducers/articleAuthor"
import { getArticleAuthorsCollectionApi } from "../../api/articleAuthor"

export const fetchArticleAuthorsAction = () => (dispatch) => {
    return getArticleAuthorsCollectionApi()
            .then(response => {
                const {data} = response
                dispatch(setArticleAuthors(data.article_authors))
                return response
            })
}