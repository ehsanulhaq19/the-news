import apiClient from './client/client'

export const postUserPrefrenceItemApi = async(payload) => {
    const {source_ids=null, author_ids=null, category_ids=null} = payload
    const client = await apiClient()

    // return client.postUserPrefrenceItem(null, { 
    //         ...(source_ids && {source_ids}),
    //         ...(author_ids && {author_ids}),
    //         ...(category_ids && {category_ids})
    //     });

    return client.post('/user-prefrences', { 
        ...(source_ids && {source_ids}),
        ...(author_ids && {author_ids}),
        ...(category_ids && {category_ids})
    })
}

export const getUserPrefrenceItemApi = async() => {
    const client = await apiClient()
    // return client.getUserPrefrenceItem();
    return client.get('/user-prefrences')
}
