import { createSlice } from '@reduxjs/toolkit'

export const articleCategoriesSlice = createSlice({
  name: 'articleCategory',
  initialState: {
    articleCategories: {}
  },
  reducers: {
    setArticleCategories: (state, action) => {
        state.articleCategories = action?.payload
    }
  },
})

export const { setArticleCategories } = articleCategoriesSlice.actions

export default articleCategoriesSlice.reducer