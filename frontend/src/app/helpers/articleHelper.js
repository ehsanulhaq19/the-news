

/**
 * Get article block ui related data
 * @param {*} article 
 * @returns 
 */
export const getArticleUiBlockData = (article) => {
    const {id, title, category, published_date, source, sub_source} = article
    const categoryName = category?.name?.toLowerCase()
    const url = getArticleUrl(categoryName, id)
    const mediaFiles = article.media_files?.length ? article.media_files : null
    const titlePlaceHolderImage = article.headline_placeholder_image
    const titleImage = mediaFiles ? (mediaFiles[0]?.url ? mediaFiles[0].url : titlePlaceHolderImage) : titlePlaceHolderImage
    
    return {
        title,
        url,
        titleImage,
        publishedDate: published_date,
        source,
        subSource: sub_source
    }
}


/**
 * Get article uri
 * @param {*} category 
 * @param {*} id 
 * @returns string
 */
 export const getArticleUrl = (category, id) => {
    return `/article/${category}/${id}`
}

/**
 * Get article by matching category and id
 * @param {*} category 
 * @param {*} id 
 * @return object|null
 */
export const getArticleByCategoryAndId = (articles, category, id) => {
    if (!articles || !Object.keys(articles) || !articles[category]) {
        return null
    }
    const categoryArticles = articles[category]
    
    for (let i = 0; i < categoryArticles.length; i++)
    {
        const article = categoryArticles[i]
        const {id: articleId} = article
        if (id == articleId) {
            return article
        }
    }

    return null
}