import { getArticleUiBlockData } from "../../helpers/articleHelper"

const NewsHeaderBlock = ({article, articleNumber}) => {
    const {title, url, titleImage} = getArticleUiBlockData(article)

    return (
        <div 
            className={`headline headline-${articleNumber}`}
            style={{background: `url(${titleImage})`}}
        >
            <a href={url} target="_blank">
                <h1>{title}</h1>
            </a>
        </div>
    )
}

export default NewsHeaderBlock