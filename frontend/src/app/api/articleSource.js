import apiClient from './client/client'

export const getArticleSourcesCollectionApi = async() => {
    const client = await apiClient()
    
    // return client.getArticleSourcesCollection();
    return client.get('/article-sources')
}