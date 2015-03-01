//
//  LoginViewController.h
//  IOU
//
//  Created by Bandi Enkh-Amgalan on 3/1/15.
//  Copyright (c) 2015 a. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <FacebookSDK/FacebookSDK.h>

@class LoginViewController;

@protocol LoginViewControllerDelegate
-(void)didLogin;
@end

@interface LoginViewController : UIViewController <FBLoginViewDelegate>
{
    FBLoginView *loginView;
    id<LoginViewControllerDelegate> delegate;
}

@property FBLoginView *loginView;
@property id<LoginViewControllerDelegate> delegate;


@end
