import ArticleBlock from "./ArticleBlock"

const ArticleSection = ({articles}) => {
    return (
        articles && Object.keys(articles)?.length ? Object.keys(articles).map((category, categoryIndex) => {
            const categoryArticles = articles[category]
            return <>
              {
                categoryArticles?.length ?             (
                  <section className={`news-section ${category.toLowerCase()}`} key={categoryIndex}>
                    <h2>{category}</h2>
                    {
                      categoryArticles?.length && categoryArticles.map((article, index) => {
                        return <ArticleBlock article={article} articleNumber={index+1} key={index}/>
                      })
                    }
                  </section>
                ) : <></>
              }
            </>
            

        }) : <></>
    )
}

export default ArticleSection