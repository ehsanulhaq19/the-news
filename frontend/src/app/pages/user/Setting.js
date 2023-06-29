import {useState, useEffect} from 'react'
import Select from 'react-select'
import { useSelector, useDispatch } from 'react-redux'
import { convertToDropdownArray } from '../../utils/form'
import { postUserPrefrenceItemAction } from '../../redux/actions/userPrefrence'
import messsages from '../../constants/messages.json'

const Setting = () => {
    //states
    const [selectedSources, setSelectedSources] = useState([])
    const [selectedCategories, setSelectedCategories] = useState([])
    const [selectedAuthors, setSelectedAuthors] = useState([])

    const [isSources, setIsSources] = useState(false)
    const [isCategories, setIsCategories] = useState(false)
    const [isAuthors, setIsAuthors] = useState(false)

    //constants
    const userPrefrenceMessages = messsages.messages.userPrefrence

    //dispatcher
    const dispatch = useDispatch()

    //selectors
    const articleSources = useSelector(state => {
        return convertToDropdownArray(state.articleSource.articleSources)
    })
    const articleAuthors = useSelector(state => {
        return convertToDropdownArray(state.articleAuthor.articleAuthors)
    })
    const articleCategories = useSelector(state => {
        return convertToDropdownArray(state.articleCategory.articleCategories)
    })
    const userPrefrence = useSelector(state => state.userPrefrence.userPrefrence)

    //functions
    const submitUserPrefrenceHanlder = async () => {
        const source_ids = selectedSources.map(source => source.value)
        const category_ids = selectedCategories.map(category => category.value)
        const author_ids = selectedAuthors.map(author => author.value)

        dispatch(
            postUserPrefrenceItemAction({
                source_ids,
                category_ids,
                author_ids
            })
        ).then(response => {
            alert(userPrefrenceMessages.createSuccess)
        }).catch(e => {
            const message = e?.response?.data?.message || userPrefrenceMessages.createError
            alert(message)
        })
    }

    const sourceChangeHandler = (data) => {
        setSelectedSources(data)
    }

    const categoryChangeHandler = (data) => {
        setSelectedCategories(data)
    }

    const authorChangeHandler = (data) => {
        setSelectedAuthors(data)
    }

    const getDefaultValue = (ids, options) => {
        if (ids && options) {
            return options.filter(option => ids.includes(option.value))
        }
        return []
    }

    //event hooks
    useEffect(() => {
        console.log("----------1--------------")
        if (!isSources && !selectedCategories.length && userPrefrence?.source_ids && articleSources.length) {
            setSelectedSources(
                getDefaultValue(userPrefrence?.source_ids, articleSources)
            )
            setIsSources(true)
        }
    }, [userPrefrence?.source_ids, articleSources])

    useEffect(() => {
        console.log("----------2--------------")
        if (!isAuthors && !selectedAuthors.length && userPrefrence?.author_ids && articleAuthors.length) {
            setSelectedAuthors(
                getDefaultValue(userPrefrence?.author_ids, articleAuthors)
            )
            setIsAuthors(true)
        }
    }, [userPrefrence?.author_ids, articleAuthors])
    
    useEffect(() => {
        console.log("----------3--------------")
        if (!isCategories && !selectedCategories.length && userPrefrence?.category_ids && articleCategories.length) {
            setSelectedCategories(
                getDefaultValue(userPrefrence?.category_ids, articleCategories)
            )
            setIsCategories(true)
        }
    }, [userPrefrence?.category_ids, articleCategories])

    return (
        <div className='setting-page'>
            <div className="wrapper bg-white mt-sm-5">
                <h4 className="pb-4 border-bottom">User Prefrences</h4>
                <div className="py-2">
                    <div className="row py-2">
                        <div className="col-md-6">
                            <label htmlFor="firstname">Source</label>
                            <Select 
                                options={articleSources} 
                                isMulti
                                onChange={sourceChangeHandler}    
                                value={selectedSources}
                            />
                        </div>
                        <div className="col-md-6 pt-md-0 pt-3">
                            <label htmlFor="lastname">Category</label>
                            <Select 
                                options={articleCategories} 
                                isMulti
                                onChange={categoryChangeHandler} 
                                value={selectedCategories}
                            />
                        </div>
                    </div>
                    <div className="row py-2">
                        <div className="col-md-6">
                            <label htmlFor="email">Author</label>
                            <Select 
                                options={articleAuthors} 
                                isMulti
                                onChange={authorChangeHandler}
                                value={selectedAuthors}
                            />
                        </div>
                    </div>

                    <div className="py-3 pb-4 border-bottom">
                        <button className="btn btn-primary mr-3" onClick={submitUserPrefrenceHanlder}>Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Setting