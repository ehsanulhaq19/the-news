import apiClient from './client/client'

export const getArticleCollectionApi = async() => {
    const client = await apiClient()
    
    // return client.getArticlesByCategoryCollection();
    return client.get('/articles-by-categories')
}

export const getArticlesBySearchCollectionApi = async(params) => {
    const client = await apiClient()
    
    // return client.getArticlesBySearchCollection(params);
    return client.get('/articles-search', {
        params
    })
}