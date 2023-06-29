import NewsHeaderBanner from "./NewsHeaderBanner"
import NewsHeaderBlock from "./NewsHeaderBlock"

const NewsHeader = ({articles}) => {
    const headArticle = articles?.length ? articles[0] : null
    return <>
        {
            articles?.length ? (
                <div className="top-news">
                    {
                        headArticle && <NewsHeaderBanner article={headArticle} />
                    }
                
                    <section className="top-stories news-section">
                        <h2>Latest Stories</h2>
                        {
                            articles.map((article, index) => {
                                if (index > 0) {
                                    return <NewsHeaderBlock article={article} articleNumber={index} key={index}/> 
                                }
                            })
                        }
                        </section>

                    </div> 
            ) : <></>
        }
    </>
}

export default NewsHeader