import { setUserPrefrence } from "../reducers/userPrefrence"
import { postUserPrefrenceItemApi, getUserPrefrenceItemApi } from "../../api/userPrefrence"

export const postUserPrefrenceItemAction = (payload) => (dispatch) => {
    return postUserPrefrenceItemApi(payload)
            .then(response => {
                const {data} = response
                dispatch(setUserPrefrence(data.user_prefrence))
                return response
            })
}

export const getUserPrefrenceItemAction = () => (dispatch) => {
    return getUserPrefrenceItemApi()
            .then(response => {
                const {data} = response
                dispatch(setUserPrefrence(data.user_prefrence))
                return response
            })
}