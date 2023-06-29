import { getArticleUiBlockData } from "../../helpers/articleHelper"

const NewsHeaderBanner = ({article}) => {
    const {title, url, titleImage} = getArticleUiBlockData(article)

    return (
        <section className="latest-news">
            <div 
                className="headline"
                style={{background: `url(${titleImage})`}}
            >
                <p>Latest News</p>
                <a href={url} target="_blank">
                    <h1>{title}</h1>
                </a>
            </div>
        </section> 
    )
}

export default NewsHeaderBanner