namespace php Overblog.ThriftBundle.Model.Comment

typedef i32 Timestamp

const i32 hex_const = 0x0001F

const i32 GEN_ME = -3523553
const double GEn_DUB = 325.532
const double GEn_DU = 085.2355
const string GEN_STRING = "asldkjasfd"

const map<i32,i32> GEN_MAP = { 35532 : 233, 43523 : 853 }
const list<i32> GEN_LIST = [ 235235, 23598352, 3253523 ]

enum State {
    STATE_NOT_APPROVED  = 0,
    STATE_APPROVED      = 1,
    STATE_DELETED       = 2,
    STATE_SPAM          = 3
}

enum TestState {
    STATE_NOT_APPROVED  = 0,
    STATE_APPROVED      = 1,
    STATE_DELETED       = 2,
    STATE_SPAM          = 3
}

struct CommentUser {
    1: string token,
    2: string origin,
    3: optional string avatar,
    4: string name,
    5: string email,
    6: optional string url,
    7: i32 ip
}

struct Comment {
    1: i64 id = 0,
    2: i64 id_element = 0,
    3: i64 id_element_parent = 0,
    4: string comment,
    5: Timestamp date,
    6: State state,
    7: CommentUser user,
    8: i32 like_count = 0,
    9: i32 dislike_count = 0,
   10: i32 popularity = 0
}

exception InvalidValueException {
    1: i32 error_code,
    2: string error_msg
}

service Comment {
    Comment getCommentById(1: i64 id) throws (1: InvalidValueException e),
    list<Comment> getCommentsByIdElement(
        1: i64 id_element,
        2: i32 offset,
        3: i32 limit,
        4: i32 offset_replies,
        5: i32 limit_replies,
        6: State state,
        7: string orderType,
        8: string orderAsc
    ),
    list<Comment> getReplies(1: i64 id),
    i64 createComment(1: Comment comment),
    i64 createReply(1: Comment comment, 2: i64 id_comment_parent),
    bool deleteComment(1: i64 id),
    bool approveComment(1: i64 id),
    bool unapproveComment(1: i64 id),
    bool markCommentAsSpam(1: i64 id),
    list<Comment> getCommentsByIdElementParent(1: i64 id_element_parent, 2: State state),
    bool like(1: i64 id) throws (1: InvalidValueException e),
    bool dislike(1: i64 id) throws (1: InvalidValueException e),
    bool initializePopularity(1: i64 id) throws (1: InvalidValueException e)
}


service Blog {
    void ping();
}