import { createSlice } from '@reduxjs/toolkit'

export const articleAuthorsSlice = createSlice({
  name: 'articleAuthor',
  initialState: {
    articleAuthors: {}
  },
  reducers: {
    setArticleAuthors: (state, action) => {
        state.articleAuthors = action?.payload
    }
  },
})

export const { setArticleAuthors } = articleAuthorsSlice.actions

export default articleAuthorsSlice.reducer