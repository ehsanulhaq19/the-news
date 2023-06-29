import apiClient from './client/client'

export const getArticleAuthorsCollectionApi = async() => {
    const client = await apiClient()
    
    // return client.getArticleAuthorsCollection();
    return client.get('/article-authors')
}