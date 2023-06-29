import { createSlice } from '@reduxjs/toolkit'

export const userPrefrenceSlice = createSlice({
  name: 'userPrefrence',
  initialState: {
    userPrefrence: {}
  },
  reducers: {
    setUserPrefrence: (state, action) => {
        state.userPrefrence = action?.payload
    }
  },
})

export const { setUserPrefrence } = userPrefrenceSlice.actions

export default userPrefrenceSlice.reducer