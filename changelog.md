# Change Log

## 2021.05.24

> Version: 0.4.2

- Medium에서 WordPress로 옮김
    - Word Press 포스팅 API 적용
    - Word Press Auto Posting Command 추가
- Posts DTO(Posts기본 DTO) 수정
    - 포스트내용(contents) 이미지 변환 후 리턴하는 getter생성
    - wkhtmltopdf라는 라이브러리 사용
        - 참고: https://github.com/wkhtmltopdf/packaging
- Open dart Client 수정
    - get요청 시, url에 쿼리스트링을 추가하지 않고, parameter매개변수에 넣어줘야 작동함

## 2021.05.11

> Version: 0.3.2

-   Medium Post Command생성
-   Dto관련 기능 분해 BaseObject를 두고 공통 기능들은 Trait으로 관리
    - 해당 수정사항 롤백

## 2021.05.07

> Version: 0.3.1

-   Windows클래스
    -   ssh를 통해 kiwoom API 실행
-   404 handle
    -   API요청이 아닌 경우에, http not found 및 resource not found 예외에 대한 handle
-   open graph 및 manifest 추가

-   auto post 커맨드 및 기능 추가

-   기존 sectors,themes config파일에서 관리했었는데, api로도 수정할 수 있게

    -   resources/lang/ko 디렉터리 및에 sectors.json, themes.json으로 저장됨
    -   기존 코드와의 호환성을 위해 config파일에서는 각 해당 json파일의 내용을 가져온다
    -   themes와 sectors의 구조가 다른 부분을 서로 같게 수정
    -   기존 API의 POST /api/themes와의 호완성을 위해 KoaService의 storeThemes메서드 수정

-   Dto관련 기능 분해 BaseObject를 두고 공통 기능들은 Trait으로 관리

-   Medium API관련 기능 구현
    -   사용자 정보 조회
    -   글쓰기

## 2021.04.28

> Version: 0.3.0

-   Bootstrap Clean Blog 템플릿 추가
    -   화면 추가
        -   Layouts: footer,list-header,main,nav,post-header
        -   Components: post-preview
        -   view: list, post
-   Route추가
    -   post
    -   post/{id}
-   일반적인 블로그 리스트, 조회 기능

> 추가 예정 개발 중

-   포스팅과 업데이트 및 삭제는 백그라운드에서 자동화

## 2021.04.27

> Version: 0.2.1

-   Refine DTO 추가

    -   기존 Finance, FinanceData 결합하여 필요한 데이터만 속성으로 가진다.

-   Absolute/html 경로 추가

    -   html 테이블 데모

-   Tistory API 토큰발급 구현

## 2021.04.20

> Version: 0.2.0

-   Route 정리
-   Absolute 패스 추가

    -   Absolute/raw: StockInfo와 Acnt를 단순히 종목 코드만으로 묶어 놓은 결과를 응답
    -   Absolute: StockInfo와 Acnt를 하나의 객체로 응답한다.(Acnt데이터에서 필요한 내용만 추출)

-   MainService 추가
    -   StockInfo(키움 주식 기본정보 데이터 객체), Acnt(open dart 재무제표 데이터 객체) 결합
-   PostStockRequest
    -   키움 주가정보 validation 및 변환 클래스

## 2021.04.13

> Version: 0.1.0

-   Services 추가
    -   OpenDartService
    -   KoaService
-   DtataTransferObjects추가
-   Entities제거

## 2021.04.09

> Version: 0.0.2

-   필요 라이브러리 생성
-   Entities
-   Generate
-   JsonMapper
-   OpenDart API 관련 클래스
    -   OpenDart Client
-   Client(Laravel Http Client Wrapper)

## 2021.04.08

> Version: 0.0.1

-   API 및 인증 모듈 추가
