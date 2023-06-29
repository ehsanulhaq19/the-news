import { useEffect, useState } from "react"
import { useDispatch, useSelector } from "react-redux"
import { fetchArticlesAction } from "../../redux/actions/article"
import ArticleSection from "../../components/newsFeed/ArticleSection"
import NewsHeader from "../../components/newsFeed/NewsHeader"

const NewsFeed = () => {
    //dispatcher
    const dispatch = useDispatch()  

    //states
    const [recentArticles, setRecentArticles] = useState()
    const [newsFeedArticles, setNewsFeedArticles] = useState()

    //selector
    const articles = useSelector(state => state.article.articles)

    //event hooks
    useEffect(() => {
      dispatch(fetchArticlesAction())
    }, [dispatch])

    useEffect(() => {
      if (Object.keys(articles)) {
        let rArticles = []
        let nfArticles = {}
        for(const cateogryName in articles) {
          if (cateogryName === "recent") {
            rArticles = articles[cateogryName]
          } else {
            nfArticles[cateogryName] = articles[cateogryName]
          }
        }

        setRecentArticles(rArticles)
        setNewsFeedArticles(nfArticles)
      }
    }, [articles])

    return (
        <div id="top" className="home-screen">
            {/* <!-- Main --> */}
            <main className="main" role="main">
              <NewsHeader articles={recentArticles}/>
              <ArticleSection articles={newsFeedArticles} /> 
          </main> 
            {/* <!-- End of className="main" --> */}
        
        </div>
    )
}

export default NewsFeed