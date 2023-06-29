import { createSlice } from '@reduxjs/toolkit'

export const articleSourcesSlice = createSlice({
  name: 'articleSource',
  initialState: {
    articleSources: {}
  },
  reducers: {
    setArticleSources: (state, action) => {
        state.articleSources = action?.payload
    }
  },
})

export const { setArticleSources } = articleSourcesSlice.actions

export default articleSourcesSlice.reducer